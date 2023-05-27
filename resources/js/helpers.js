const base_url = document.querySelector("#app").dataset.url;

export default function helpers(app){
    app.provide('base_url', base_url);
}