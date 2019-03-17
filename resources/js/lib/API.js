const API_URL = 'http://borsaTreball.my/api/';
//const API_URL = 'http://localhost:3000/';
const myId=1;
// const config = {
//     headers: {
//       'Authorization': sessionStorage.user_data.token_type+' '
//         +sessionStorage.user_data.user_data.access_token,
//       'Content-Type': 'application/json'
//     }
// }

function checkAuth() {
    if (!sessionStorage.user_data ||
        new Date(sessionStorage.user_data.expires_at)<new Date()) {
            return false;
    }
    return {
        headers: {
          'Authorization': sessionStorage.user_data.token_type+' '
            +sessionStorage.user_data.user_data.access_token,
          'Content-Type': 'application/json'
        }
    }
}

import axios from 'axios'


export default {
    getTable(table, query) {
        const config=checkAuth();
        if (!config && table!='menu') {
            console.log('pido datos');
//            this.$router.push('/login');
            return false;
        }
        if (query) {
            let queryString = '';
            for (let i in query) {
                queryString += i + '=' + query[i] + '&';
            }
            queryString = queryString.substr(0, queryString.length - 1);
            return axios.get(API_URL + table + '?' + queryString, config);
        } else {
            return axios.get(API_URL + table, config);
        }
    },
    getItem(table, id = myId) {
        return axios.get(API_URL + table + '/' + id, config);
    },
    delItem(table, id) {
        return axios.delete(API_URL + table + '/' + id, config);
    },
    saveItem(table, item) {
        return axios.post(API_URL + table, item, config);
    },
    updateItem(table, id, item) {
        return axios.put(API_URL + table + '/' + id, item, config);
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
        return axios.get(API_URL + 'users/', item, config)
    },
    saveUser(item) {
        // Convertimos el objeto a urlencoded
        let pairs = [];
        for (var prop in item) {
            if (item.hasOwnProperty(prop)) {
                var k = encodeURIComponent(prop),
                    v = encodeURIComponent(item[prop]);
                pairs.push( k + "=" + v);
            }
        }
        const str = pairs.join("&");

        const configRegister = {
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
        }

        return axios.post(API_URL + 'auth/signup', str, configRegister);
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
        return axios.post(API_URL + 'users/', item, config);
    },
    sendMail(mail) {
        return axios.post(API_URL + '/mail', mail, config);
    }
}