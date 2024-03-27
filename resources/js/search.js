const min_age_filter = document.querySelector("#filter_min_age"),
    min_age_val = document.querySelector("#min_age_val"),
    max_age_filter = document.querySelector("#filter_max_age"),
    max_age_val = document.querySelector("#max_age_val");
min_age_filter.addEventListener("change", (e) => {
    min_age_val.innerText = e.target.value;
});
max_age_filter.addEventListener("change", (e) => {
    max_age_val.innerText = e.target.value;
});
