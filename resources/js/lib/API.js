const API_URL = 'http://borsaTreball.my/api/';
const config = {
    headers: {
      'Authorization': sessionStorage.token_type+' '
        +sessionStorage.access_token,
      'Content-Type': 'application/json'
    }
}
const configLogin = {
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
}

import axios from 'axios'

function checkAuth() {
    return (sessionStorage.expires_at &&
        new Date(sessionStorage.expires_at)>new Date())
}

function json2urlencoded(json) {
    let pairs = [];
    for (var prop in json) {
        if (json.hasOwnProperty(prop)) {
            var k = encodeURIComponent(prop),
                v = encodeURIComponent(json[prop]);
            pairs.push( k + "=" + v);
        }
    }
    return pairs.join("&");
}
export default {
    getTable(table, query) {
        console.log('get table')
        if (!checkAuth() && table!='menu') {
            console.log('pido datos');
//            this.$router.push('/login');
            return new Promise((resolve,reject)=>{
                reject(new Error('No estás validado'))
            });
        }
        if (query) {
            return axios.get(API_URL + table + '?' + json2urlencoded(query), config);
        } else {
            return axios.get(API_URL + table, config);
        }
    },
    getItem(table, id) {
        console.log('get item')
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
        // return new Promise(function(resolve) {
        //     resolve({
        //         data: {
        //             id:5,
        //             user:item.user,
        //             rol:2,
        //             token:'asdad6acguas6utash768a'
        //         }    
        //     })
        // });
        return axios.post(API_URL + 'auth/login', json2urlencoded(item), configLogin)
    },
    saveUser(item) {
        return axios.post(API_URL + 'auth/signup', json2urlencoded(item), configLogin);
    },
    logoutUser() {
        return axios.get(API_URL + 'auth/logout', configLogin);
    },
    sendMail(mail) {
        return axios.post(API_URL + '/mail', mail, config);
    }
}