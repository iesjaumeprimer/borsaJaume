const API_URL = 'http://borsaTreball.my/api/';
//const API_URL = 'http://localhost:3000/';
const myId=1;
import axios from 'axios'

export default {
    getTable(table, query) {
        if (query) {
            let queryString = '';
            for (let i in query) {
                queryString += i + '=' + query[i] + '&';
            }
            queryString = queryString.substr(0, queryString.length - 1);
            return axios.get(API_URL + table + '?' + queryString);
        } else {
            return axios.get(API_URL + table);
        }
    },
    getItem(table, id = myId) {
        return axios.get(API_URL + table + '/' + id);
    },
    delItem(table, id) {
        return axios.delete(API_URL + table + '/' + id);
    },
    saveItem(table, item) {
        return axios.post(API_URL + table, item);
    },
    updateItem(table, id, item) {
        return axios.put(API_URL + table + '/' + id, item);
    },
    getUser(item) {
        // prova
        return new Promise(function(resolve) {
            resolve({
                data: {
                    id:5,
                    user:item.user,
                    rol:2,
                    token:'asdad6acguas6utash768a'
                }    
            })
        });
        return axios.get(API_URL + 'users/', item)
    },
    saveUser(item) {
        return axios.post(API_URL + 'auth/signup', item, 
            {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
            }});
        // prova
       return response={
           data: {
               id:5,
               user:item.user,
               rol:2,
               token:'asdad6acguas6utash768a'
           }
       }
        // No se usa saveItem porque hay que guardarlo en Users y en Alumnos/Empresas
        return axios.post(API_URL + 'users/', item);
    },
    sendMail(mail) {
        return axios.post(API_URL + '/mail', mail);
    }
}