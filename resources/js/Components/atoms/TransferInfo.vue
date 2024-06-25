<script setup lang="ts">
import Card from "./Card.vue";
</script>

<template>
    <Card>
        <template #title> Stay secured </template>
        <template #subtitle>
            Take a minute to educate yourself about internet safety
        </template>
        <template #content>
            <div class="transfer-info">
                <p>
                    Ensuring the safety of your online money transfers is
                    crucial. Always use trusted platforms that offer encryption
                    to protect your personal and financial information.
                    Encryption converts your data into a secure code, ensuring
                    only the intended recipient can access it.
                </p>
                <p>
                    Use strong, unique passwords and enable two-factor
                    authentication (2FA) for an extra layer of security. Avoid
                    easily guessable passwords and instead, use a mix of
                    letters, numbers, and special characters. 2FA requires not
                    just your password but also a second form of identification,
                    like a text message code.
                </p>
                <p>
                    Regularly monitor your accounts to spot unauthorized
                    activities quickly. Setting up account alerts can help you
                    stay informed about any changes or transactions, adding an
                    extra safeguard against fraud.
                </p>
                <p>
                    Be cautious of phishing scams and unsolicited requests for
                    financial information. Verify the authenticity of emails or
                    messages claiming to be from your bank. Contact your bank
                    directly using a known phone number or official website to
                    confirm any suspicious communication. These practices will
                    help ensure your money transfers remain secure and your
                    information protected.
                </p>
            </div>
        </template>
    </Card>
</template>

<style scoped lang="scss">
.transfer-info {
    @apply flex flex-col gap-4;
}
</style>
