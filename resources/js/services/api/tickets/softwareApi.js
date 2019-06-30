export default {
  async get(page = 1) {
    const res = await axios.get('programs/?page=' + page);
    return res.data;
  },
  async show(id) {
    const res = await axios.get(`programs/${id}`);
    return res.data;
  },
  async store(data) {
    const res = await axios.post(`programs`, data);
    return res.data;
  },
  async update(id, data) {
    const res = await axios.put(`programs/${id}`, data);
    return res.data;
  },
}