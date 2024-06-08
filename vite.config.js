import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue"; //add this line
import laravel from "laravel-vite-plugin";
import path from 'path'  //burası eklendi bootstrap için
export default defineConfig({
    plugins: [
        vue(), // write this
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    resolve: { //burası eklendi bootstrap için
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
});