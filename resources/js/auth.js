import axios from 'axios';

class Auth {
    constructor() {
        this.token = window.localStorage.getItem('login_token');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
    }
    async authCheck() {
        if (!this.token) {
            console.log('failed');
            return false;
        }

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;

        let { data } = await axios.get('/api/me');
        console.log(data);
        if (data) {
            this.user = data.user;
            return true;
        } else {
            this.logoutAuthToken();
            console.log('failed');
            return false;
        }
    }
    setAuthToken(token) {
        if (token) {
            this.token = token;
            window.localStorage.setItem('login_token', token);
        }
    }
    logoutAuthToken() {
        window.localStorage.removeItem('login_token');
    }
}

export default new Auth;