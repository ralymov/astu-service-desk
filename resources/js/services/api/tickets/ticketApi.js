import sweetAlert from '../../../mixins/sweet_alert';

export default {
  async get() {
    const res = await axios.get('tickets');
    return res.data;
  },
  async show(id) {
    const res = await axios.get(`tickets/${id}`);
    return res.data;
  },
  async edit(id) {
    const res = await axios.get(`tickets/${id}/edit`);
    return res.data;
  },
  async update(id, data) {
    const res = await axios.put(`tickets/${id}`, data);
    sweetAlert.methods.alertSuccess();
    return res.data;
  },
  async lock(id) {
    const res = await axios.get(`tickets/lock/${id}`);
    return res.data;
  },
  async unlock(id) {
    const res = await axios.get(`tickets/unlock/${id}`);
    return res.data;
  },
  async complete(id) {
    const res = await axios.get(`tickets/complete/${id}`);
    return res.data;
  },
  async cancelComplete(id) {
    const res = await axios.get(`tickets/cancel-complete/${id}`);
    return res.data;
  },
}
