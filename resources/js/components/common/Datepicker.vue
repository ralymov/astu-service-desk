<template>
  <datepicker-inner
      :config="config"
      :placeholder="placeholder"
      :value="value"
      :class="inputClass"
      @input="changeDate"
      :required="required"/>
</template>

<script>
  import DatepickerInner from 'vue-flatpickr-component';
  import flatpickr from "flatpickr";
  import {Russian} from "flatpickr/dist/l10n/ru.js";

  flatpickr.localize(Russian);

  export default {
    name: "Datepicker",
    components: {
      DatepickerInner
    },
    props: {
      value: {
        type: [Date, String],
        default: '',
      },
      dateFormat: {
        type: String,
        default: "Y-m-d"
      },
      altFormat: {
        type: String,
        default: "d.m.Y"
      },
      enableTime: {
        type: Boolean,
        default: false,
      },
      inputClass: '',
      placeholder: '',
      required: {
        type: Boolean,
        default: false,
      }
    },
    data() {
      return {
        date: null,
        config: {
          wrap: false,
          dateFormat: this.dateFormat,
          altInput: true,
          altFormat: this.altFormat,
          locale: Russian,
          allowInput: true,

          enableTime: this.enableTime,
          time_24hr: this.enableTime
        },
      }
    },
    methods: {
      changeDate(date) {
        this.$emit('input', date);
      },
    }
  }
</script>

