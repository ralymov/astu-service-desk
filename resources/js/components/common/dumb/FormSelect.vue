<template>
  <b-form-select v-model="dataValue"
                 :options="options"
                 :text-field="textField"
                 :value-field="valueField"
                 @input="input"
                 :required="required">
    <template slot="first">
      <option :value="firstElement.value" disabled>{{firstElement.text}}</option>
    </template>
  </b-form-select>
</template>

<script>
  export default {
    name: "FormSelect",
    props: {
      options: {
        type: Array,
        default: [],
      },
      firstElement: {
        type: Object,
        default: function () {
          return {
            text: 'Выберите один из вариантов',
            value: null,
          }
        }
      },
      textField: {
        type: [String, Number],
        default: 'name',
      },
      valueField: {
        type: [String, Number],
        default: 'id',
      },
      required: {
        type: Boolean,
        default: false,
      },
      value: null,
    },
    data() {
      return {
        dataValue: this.value || null,
      }
    },
    methods: {
      input() {
        this.$emit('input', this.dataValue);
      }
    }
  }
</script>

