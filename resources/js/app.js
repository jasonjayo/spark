import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

navigator.geolocation.getCurrentPosition((pos) => {
    axios.post(`${URL_BASE}/api/geolocation`, {
        location: `${pos.coords.latitude}, ${pos.coords.longitude}`,
    });
});
