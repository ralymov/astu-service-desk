export default {
  async get() {
    const res = await axios.get('/ticketPriorities');
    return res.data;
  }
}