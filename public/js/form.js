document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("paymentForm");
    const payButton = document.getElementById("payButton");

    const creditCard = document.getElementById("creditCard");
    const cryptogram = document.getElementById("cryptogram");
    const nameCard = document.getElementById("nameCard");
    const nameCardPattern = /^(?:M|MME\s)?[A-ZÀ-Ö]{1,20}(?:['-][A-ZÀ-Ö]{1,20})*\s[A-ZÀ-Ö]{1,20}(?:['-][A-ZÀ-Ö]{1,20})*$/;

    if (!form || !payButton || !creditCard || !cryptogram || !nameCard) return;

    // =========================
    // FORMAT CARTE (XXXX XXXX ...)
    // =========================
    function formatCard(value) {
        return value
            .replace(/\D/g, "")
            .replace(/(.{4})/g, "$1 ")
            .trim();
    }

    creditCard.addEventListener("input", () => {
        const cursor = creditCard.selectionStart;

        const oldLength = creditCard.value.length;
        creditCard.value = formatCard(creditCard.value);
        const newLength = creditCard.value.length;

        const diff = newLength - oldLength;

        creditCard.setSelectionRange(cursor + diff, cursor + diff);

        validateForm();
    });

    // =========================
    // VALIDATION VISUELLE + LOGIQUE
    // =========================
    function verifier(champ) {
        let valid = true;
        const value = champ.value.trim();

        switch (champ.name) {

            case "name":
            case "surname":
            case "user":
                if (value.length === 0) {valid = null;}
                else {valid = value.length >= 2;}
                break;

            case "password":
            case "email":
            case "date":
                if (value.length === 0) {valid = null;}
                else {valid = value.length >= 8;}
                break;

            case "creditCard":
                if (value.length === 0) {valid = null;}
                else {valid = value.replace(/\s/g, "").length >= 13;}
                break;

            case "cryptogram":
                if (value.length === 0) {valid = null;}
                else {valid = value.length >= 3;}
                break;

            case "nameCard":
                if (value.length === 0) {valid = null;}
                else {
                    if (nameCardPattern.test(nameCard.value.trim())) {valid = true;}
                    else {valid=false;}}
                break;
        }

        champ.style.border = value === ""
            ? "2px solid black"
            : valid
                ? "3px solid green"
                : "3px solid red";

        return valid;
    }

    // =========================
    // MESSAGES ✔ / ✘
    // =========================
    function confirmer(champ, ok) {
    const msg = document.getElementById("msg_" + champ.name);
    if (!msg) return;

    msg.textContent = ok === null ? " " : (ok ? "✅" : "❌");
}

    // =========================
    // VALIDATION GLOBALE
    // =========================
    function validateForm() {

        let allValid = true;

        [creditCard, cryptogram, nameCard].forEach(champ => {
            const ok = verifier(champ);
            confirmer(champ, ok);
            allValid = allValid && ok;
        });

        payButton.disabled = !allValid;
        payButton.style.opacity = allValid ? "1" : "0.5";
        payButton.style.cursor = allValid ? "pointer" : "not-allowed";
    }

    // =========================
    // EVENTS INPUT + BLUR
    // =========================
    [creditCard, cryptogram, nameCard].forEach(champ => {

        champ.addEventListener("input", validateForm);
        champ.addEventListener("blur", validateForm);
    });

    // init
    validateForm();
});