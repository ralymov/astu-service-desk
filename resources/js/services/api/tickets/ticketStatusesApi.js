export default {
  async get() {
    const res = await axios.get('ticketStatuses');
    return res.data;
  }
}