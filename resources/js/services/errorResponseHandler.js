import axios from 'axios'
import SweetAlert from '../mixins/sweet_alert';

function errorResponseHandler(error) {
  // check for errorHandle config
  if (error.config.hasOwnProperty('errorHandle') && error.config.errorHandle === false) {
    return Promise.reject(error);
  }
  
  // if has response show the error
  if (error.response) {
    SweetAlert.methods.alertError(error.response.data.message);
    return Promise.reject(error);
  }
}

// apply interceptor on response
axios.interceptors.response.use(
  response => response,
  errorResponseHandler
);

export default errorResponseHandler;
