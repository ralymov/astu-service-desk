<template>
  <div>

    <b-row>
      <b-col cols="4" v-for="(computer,i) in event.computers" :key="i">
        <b-card header-tag="header"
                footer-tag="footer"
                class="event-card mt-3">

          <h4 slot="header" class="mb-0">Компьютер №{{i+1}}</h4>

          <b-form>
            <b-container fluid>

              <b-row class="my-1">
                <b-col sm="3">
                  <label for="inputProcessor">Процессор:</label>
                </b-col>
                <b-col sm="9">
                  <select-search id="inputProcessor"
                                 v-model="computer.processor_id"
                                 searchTable="processors"
                                 searchField="name">
                  </select-search>
                </b-col>
              </b-row>

              <b-row class="my-1">
                <b-col sm="3">
                  <label for="inputRam">ОЗУ:</label>
                </b-col>
                <b-col sm="9">
                  <select-search id="inputRam"
                                 v-model="computer.ram_id"
                                 searchTable="ram"
                                 searchField="name">
                  </select-search>
                </b-col>
              </b-row>

            </b-container>
          </b-form>
        </b-card>
      </b-col>
    </b-row>

    <b-button variant="success" type="submit" class="mr-1 mt-3" @click="save">
      Сохранить
    </b-button>

  </div>
</template>

<script>
  import eventApi from "api/tickets/eventApi";

  export default {
    name: "Event",
    components: {},
    data() {
      return {
        event: {
          name: '',
          date: null,
          computers_number: null,
          computers: [],
        },
      }
    },
    created() {
      this.fetchData();
    },
    methods: {
      save() {
        eventApi.update(this.$route.params.id, {computers: this.event.computers});
        this.alertSuccess();
      },
      async fetchData() {
        if (!this.hasId()) return;
        this.event = await eventApi.show(this.$route.params.id);
        this.processComputers();
      },
      processComputers() {
        const vm = this;
        if (!this.event.computers) {
          for (let i = 0; i < this.event.computers_number; i++) {
            vm.event.computers.push({});
          }
        } else {
          for (let i = 0; i < this.event.computers_number; i++) {
            if (!vm.event.computers[i]) vm.$set(vm.event.computers, i, {});
            else if (vm.event.computers[i].length === 0) vm.$set(vm.event.computers, i, {});
          }
        }
      }
    }
  }
</script>