const generateAISuggestionsBtn = document.querySelector(
        "#generateAISuggestionsBtn"
    ),
    loader = document.querySelector("#loader"),
    deleteAccountConfirm = document.querySelector("#deleteAccountConfirm");
if (generateAISuggestionsBtn) {
    generateAISuggestionsBtn.addEventListener("click", (e) => {
        loader.classList.remove("d-none");
        loader.classList.add("d-flex");
    });
}
if (deleteAccountConfirm) {
    deleteAccountConfirm.addEventListener("click", (e) => {
        document.querySelector("#deleteUserForm").submit();
    });
}
