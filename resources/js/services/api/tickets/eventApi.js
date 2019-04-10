export default {
  async get(page = 1) {
    const res = await axios.get('events/?page=' + page);
    return res.data;
  },
  async show(id) {
    const res = await axios.get(`events/${id}`);
    return res.data;
  },
  async store(data) {
    const res = await axios.post(`events`, data);
    return res.data;
  },
  async update(id, data) {
    const res = await axios.put(`events/${id}`, data);
    return res.data;
  },
}