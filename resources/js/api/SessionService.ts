import axios from "axios";

export const setSelectedAccount = async (accountId: number) => {
    return await axios.post(route("set-account"), { accountId });
};
