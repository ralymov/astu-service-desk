export default {
  methods: {
    hasId() {
      return this.$route.params.id;
    },
    findByField(array = [], field = null, value = null) {
      return array.findIndex(item => item[field] === value);
    },
    findById(array = [], id = null) {
      return this.findByField(array, 'id', id);
    },
    getElementById(array = [], id = null) {
      return array[this.findById(array, id)];
    },
    getById(array = [], id = null) {
      return array[this.findById(array, id)];
    },
    getByField(array = [], field = null, value = null) {
      let result = array[this.findByField(array, field, value)];
      if (!result) return {};
      return result;
    },
    deleteById(array = [], id = null) {
      array.splice(this.findById(array, id), 1)
    },
    deleteByField(array = [], field = null, value = null) {
      array.splice(this.findByField(array, field, value), 1)
    },
    deleteFromArray(array = [], value = null) {
      let index = array.indexOf(value);
      if (index !== -1) array.splice(index, 1);
    },
    convertManyToManyToIdArray(relation = []) {
      return _.map(relation, item => item.id);
    },
    toHHMMSS(initSeconds = 0) {
      var sec_num = parseInt(initSeconds, 10);
      var hours = Math.floor(sec_num / 3600);
      var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
      var seconds = sec_num - (hours * 3600) - (minutes * 60);

      // if (hours < 10) {
      //   hours = "0" + hours;
      // }
      // if (minutes < 10) {
      //   minutes = "0" + minutes;
      // }
      // if (seconds < 10) {
      //   seconds = "0" + seconds;
      // }
      return hours + ' ч. ' + minutes + ' мин. ' + seconds + ' с.';
    },
    diffInDays(date1, date2 = new Date()) {
      date1 = new Date(date1);
      date2 = new Date(date2);
      let differenceInTime = date2.getTime() - date1.getTime();
      return Math.floor(differenceInTime / (1000 * 3600 * 24));
    }
  }
}
