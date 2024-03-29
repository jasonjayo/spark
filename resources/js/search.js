const min_age_filter = document.querySelector("#filter_min_age"),
    min_age_val = document.querySelector("#min_age_val"),
    max_age_filter = document.querySelector("#filter_max_age"),
    max_age_val = document.querySelector("#max_age_val"),
    form = document.querySelector("#filters_form"),
    interest_options = document.querySelectorAll(".interest_option"),
    interests_filter = document.querySelector("#filter_interests"),
    interest_pills = document.querySelectorAll(".interest-pill"),
    interest_pill_close_btns = document.querySelectorAll(
        ".interest-pill .btn-close"
    );
let interests_selected = [];

const filter_inputs = document.querySelectorAll(
    "#filters_form input, #filters_form select"
);
min_age_filter.addEventListener("input", (e) => {
    min_age_val.innerText = e.target.value;
});
max_age_filter.addEventListener("input", (e) => {
    max_age_val.innerText = e.target.value;
});
filter_inputs.forEach((input) => {
    input.addEventListener("change", () => {
        form.submit();
    });
});
// bring in from previous search
interests_filter.value.split(",").forEach((interest) => {
    interests_selected.push(interest);
    interests_selected = interests_selected.filter((x) => x != "");
});
// add event listener to each dropdown item
interest_options.forEach((interest_option) => {
    interest_option.addEventListener("click", (e) => {
        const interest_id = e.target.getAttribute("data-interest-id");
        if (interests_selected.includes(interest_id)) {
            removeSelectedInterest(interest_id);
        } else {
            interests_selected.push(interest_id);
        }
        updateInterestsSelectedInput();
        form.submit();
    });
});
// add event listener to remove buttons on badges
interest_pill_close_btns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        removeSelectedInterest(
            e.target.parentElement.getAttribute("data-interest-id")
        );
        updateInterestsSelectedInput();
        form.submit();
    });
});
// update hidden input
function updateInterestsSelectedInput() {
    if (interests_selected.length > 0) {
        let interests_selected_serialised = "";
        interests_selected.forEach((interest_selected) => {
            interests_selected_serialised += interest_selected + ",";
        });
        interests_filter.value = interests_selected_serialised;
    } else {
        interests_filter.value = "";
    }
}
function removeSelectedInterest(interest_id) {
    interests_selected.splice(interests_selected.indexOf(interest_id), 1);
}
