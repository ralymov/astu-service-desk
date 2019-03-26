export default {
  async store(data) {
    const res = await axios.post('ticketComments', data);
    return res.data;
  }
}