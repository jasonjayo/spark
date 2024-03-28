const min_age_filter = document.querySelector("#filter_min_age"),
    min_age_val = document.querySelector("#min_age_val"),
    max_age_filter = document.querySelector("#filter_max_age"),
    max_age_val = document.querySelector("#max_age_val"),
    form = document.querySelector("#filters_form");
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
