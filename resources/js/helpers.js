import moment from 'moment';
import { notify } from "@kyvg/vue3-notification";

const base_url = document.querySelector("#app").dataset.url;

/*
 * Fonction de conversation d'heures
 */
const convertDate = (date) => 
{
    if (!date) return '';
    return moment(date).format('DD/MM/YYYY');
}

/*
 * Affiche les succès et les erreurs
 */
const showSuccessErrors = (message, type = 'success') => {
    let string = '<ul>';
    if(Array.isArray(message)){
        message.forEach(function(item){
            string += '<li>'+item+'</li>';
        })
        
    }else{
        string += '<li>'+message+'</li>';;
    }
    string += '</ul>';

    return notify({
        group: 'success_error',
        title: 'Succès',
        type: type,
        duration: 5000,
        text: string
    });
}

/*
 * Si un ou plusieurs messages du back-end, on push le ou les messages dans la variable errors
 */
const parseErrorMessage = (message) => {
    let errors = [];
    if(message != null){
        if((typeof message === 'object' && !Array.isArray(message)) || Array.isArray(message)){
            Object.keys(message).map(function(objectKey, index) {
                let value = message[objectKey];
                errors.push(value[0]);
            });
        }else{
            errors.push(message);
        }
    }

    return errors;
}


export default function helpers(app){
    app.provide('base_url', base_url);
    app.provide('convertDate', convertDate);
    app.provide('showSuccessErrors', showSuccessErrors);
    app.provide('parseErrorMessage', parseErrorMessage);
}