import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

const nav = document.querySelector("#nav");

if (typeof user_id !== "undefined" && user_id !== null) {
    navigator.geolocation.getCurrentPosition((pos) => {
        axios.post(`${URL_BASE}/api/geolocation`, {
            location: `${pos.coords.latitude}, ${pos.coords.longitude}`,
        });
    });

    Echo.private(`App.Models.User.${user_id}`).listen(
        "NotificationSent",
        (e) => {
            let data = Alpine.$data(nav);
            data["notificationsCount"] += 1;
        }
    );
}
