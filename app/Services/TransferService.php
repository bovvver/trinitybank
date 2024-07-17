<?php
namespace App\Services;

use App\Http\Requests\TransferRequest;
use App\Repositories\TransferRepository;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class TransferService extends Service
{
    protected TransferRepository $transferRepository;

    public function __construct(TransferRepository $transferRepository)
    {
        $this->transferRepository = $transferRepository;
    }

    private function validateTransferData($sender, $receiver, $amount)
    {
        if ($sender === null)
            throw new NotFoundResourceException("Sender account not found.");
        if ($receiver === null)
            throw new NotFoundResourceException("Receiver account not found.");
        if ((float) $sender->balance < (float) $amount)
            throw new BadRequestException("Insufficient resources to perform this acction.");
    }

    public function sendTransfer(TransferRequest $request)
    {
        $senderCard = $request->sender_card;
        $receiverAccountNumber = $request->account_number;
        $userId = auth()->user()->id;

        $accountsData = $this->transferRepository->getTransferAccounts($userId, $senderCard, $receiverAccountNumber);

        $sender = $accountsData['sender'];
        $receiver = $accountsData['receiver'];

        try {
            $this->validateTransferData($sender, $receiver, $request->amount);
        } catch (NotFoundResourceException $e) {
            return $this->errorResponse($e->getMessage(), "Error", Response::HTTP_NOT_FOUND);
        } catch (BadRequestException $e) {
            return $this->errorResponse($e->getMessage(), "Error", Response::HTTP_BAD_REQUEST);
        }

        $this->createNewTransfer($sender, $receiver, $request);

        return $this->successResponse("Transfer sent.");
    }

    private function createNewTransfer($sender, $receiver, $request)
    {
        $amount = $request->amount;
        $finalAmount = $amount;

        $date = Carbon::parse($request->date);
        $date = $date->isToday() ? Carbon::now() : $date;

        if ($sender->currency !== $receiver->currency) {
            $exchangeRates = $this->transferRepository->getExchangeRates($sender, $receiver);

            $targetExchangeRate = $exchangeRates[$receiver->currency];
            $baseExchangeRate = $exchangeRates[$sender->currency];

            $finalAmount = $amount / $baseExchangeRate * $targetExchangeRate;
        }

        $this->transferRepository->makeTransfer($sender, $receiver, $request->message, $request->category, $finalAmount, $date);

        $this->transferRepository->removeFromBalance($sender->id, $amount);

        if ($date->isToday())
            $this->transferRepository->addToBalance($receiver->id, $amount);
    }
}