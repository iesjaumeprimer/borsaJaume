const API_URL = 'http://borsaTreball.my/api/';

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
    getConfig(auth) {
        if (auth) return {
                headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
                }
            }
        else return {
                headers: {
                'Authorization': sessionStorage.token_type+' '
                    +sessionStorage.access_token,
                'Content-Type': 'application/json'
            }
        }
    },
    getTable(table, query) {
        const config={
            headers: {
            'Authorization': sessionStorage.token_type+' '
                +sessionStorage.access_token,
            'Content-Type': 'application/json'
        }
    }
        console.log('get table')
        if (!checkAuth() && table!='menu') {
            console.log('pido datos');
//            this.$router.push('/login');
            return new Promise((resolve,reject)=>{
                reject(new Error('No estás validado'))
            });
        }
        if (query) {
            return axios.get(API_URL + table + '?' + json2urlencoded(query), this.getConfig());
        } else {
            return axios.get(API_URL + table, config);
        }
    },
    getItem(table, id) {
        console.log('get item')
        return axios.get(API_URL + table + '/' + id, this.getConfig());
    },
    delItem(table, id) {
        return axios.delete(API_URL + table + '/' + id, this.getConfig());
    },
    saveItem(table, item) {
        return axios.post(API_URL + table, item, this.getConfig());
    },
    updateItem(table, id, item) {
        return axios.put(API_URL + table + '/' + id, item, this.getConfig());
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
        return axios.post(API_URL + 'auth/login', json2urlencoded(item), this.getConfig(true))
    },
    saveUser(item) {
        return axios.post(API_URL + 'auth/signup', json2urlencoded(item), this.getConfig(true));
    },
    logoutUser() {
        return axios.get(API_URL + 'auth/logout', this.getConfig(true));
    },
    sendMail(mail) {
        return axios.post(API_URL + '/mail', mail, this.getConfig());
    }
}