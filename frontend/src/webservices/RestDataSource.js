import axios from "axios";

export class RestDataSource {
  constructor(base_url, errorCallback) {
    this.BASE_URL = base_url;
    this.handleError = errorCallback;
  }

  getData(callback) {
    this.sendRequest("get", this.BASE_URL, callback);
  }

  getOne(id, callback) {
    this.sendRequest("get", `${this.BASE_URL}/${id}`, callback);
  }

  store(data, callback) {
    this.sendRequest("post", this.BASE_URL, callback, data);
  }

  update(data, callback) {
    this.sendRequest("put", `${this.BASE_URL}/${data['@id'].replace(/\/api\/.*\//i, '')}`, callback, data);
  }

  delete(data, callback) {
    this.sendRequest("delete", `http://localhost:8000${data['@id']}`, callback, null);
  }

  async sendRequest(method, url, callback, data) {
    let response;
    try {
      response = await axios.request({
        method: method,
        url: url,
        data: data,
        withCredentials: true,
      });
    } catch(error) {
      this.handleError("Niepowodzenie: błąd operacji sieciowej");
      window.location.replace(`/error/${error.response.status}/${error.response.data["hydra:description"]}`);
    }
    callback(response.data);
  }
}
