import axios from "axios";

const axiosInstance =  axios.create({
  baseURL: 'http://localhost:8000'
})

export async function login(email, password, callback) {
  await makePostRequest('login', email, password, callback);
}

export async function register(email, password, callback) {
  await makePostRequest('api/users', email, password, callback);
}

export async function makePostRequest(url, email, password, callback) {
  let r;

  try {
    r = await axiosInstance.post(url, {
      email: email,
      password: password
    }, {
      withCredentials: true
    })
  } catch(error) {
    callback(error.response.status)
    return;
  }
  callback(r.status);
}

export function logout() {
  axiosInstance.get('logout', {
    withCredentials: true
  })
    .catch((e) => { });
}
