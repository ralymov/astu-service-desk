<template>
  <b-modal :id="id" :title="title" @ok="handleOk" @cancel="handleCancel" :visible="value"
           @change="change" class="confirmation-modal" ok-title="OK" cancel-title="Отмена">
    <p>{{text}}</p>
  </b-modal>
</template>

<script>
  export default {
    name: 'ConfirmationModal',
    props: {
      title: {
        type: String,
        default: 'Подтвердите действие'
      },
      text: {
        type: String,
        default: 'Вы действительно хотите выполнить данное действие?'
      },
      id: {
        type: String,
        default: 'ConfirmationModal'
      },
      value: {
        type: Boolean,
        default: false,
      },
    },
    methods: {
      handleOk() {
        this.$emit('ok');
      },
      handleCancel() {
        this.$emit('cancel');
      },
      change(visible) {
        this.$emit('input', visible);
      }
    }
  }
</script>

<style lang="scss">
  .confirmation-modal {
    p {
      margin-top: -20px;
      margin-bottom: 0;
    }
    .modal-footer {
      padding-top: 10px;
      padding-bottom: 10px;
    }
  }
</style>
