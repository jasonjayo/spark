import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/guest.css",
                "resources/js/search.js",
                "resources/css/search.css",
                "resources/js/chat.js",
            ],
            refresh: true,
        }),
    ],
});
