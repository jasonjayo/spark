var traitInput = document.querySelector("#traits");
var interestInput = document.querySelector("#interests");
traitInput.value = selectedTraits.toString();
interestInput.value = selectedInterests.toString();

window.addSelectedInterest = function (e) {
    var interestId = e.getAttribute("data-interest-id");
    if (!selectedInterests.includes(interestId)) {
        selectedInterests.push(interestId);
        e.classList.add("on");
    } else {
        e.classList.remove("on");
        var removeIndex = selectedInterests.indexOf(interestId);
        selectedInterests.splice(removeIndex, 1);
    }
    interestInput.value = selectedInterests.toString();
};
window.addSelectedTrait = function (e) {
    var traitId = e.getAttribute("data-trait-id");
    if (!selectedTraits.includes(traitId)) {
        selectedTraits.push(traitId);
        e.classList.add("onTwo");
    } else {
        e.classList.remove("onTwo");
        var removeIndex = selectedTraits.indexOf(traitId);
        selectedTraits.splice(removeIndex, 1);
    }
    traitInput.value = selectedTraits.toString();
};
const interestsTraitsForm = document.querySelector("#interestsTraitsForm");
interestsTraitsForm.addEventListener("submit", (e) => {
    e.preventDefault();
    axios
        .post(`${URL_BASE}/api/interestsTraits`, {
            interests: interestInput.value,
            traits: traitInput.value,
            id: document.querySelector("#user_id").value,
        })
        .then((res) => {
            const interestsTraitsUpdateAlert = document.querySelector(
                "#interestsTraitsUpdateAlert"
            );
            interestsTraitsUpdateAlert.style.display = "block";
            setTimeout(() => {
                interestsTraitsUpdateAlert.style.display = "none";
            }, 3000);
        });
});
