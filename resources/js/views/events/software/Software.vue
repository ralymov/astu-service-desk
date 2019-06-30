<template>
  <b-card header-tag="header"
          footer-tag="footer"
          class="software-card">

    <h4 slot="header" class="mb-0">Программное обеспечение</h4>

    <b-form @submit.prevent="storeOrUpdate" id="softwareCreateForm">
      <b-container fluid>

        <b-row class="my-1">
          <b-col sm="3">
            <label>Название:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.name"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Коэффициент для количества процессоров:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.processor_number_factor" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Свободный член для количества процессоров:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.processor_number_offset" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Коэффициент для частоты процессора:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.processor_frequency_factor" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Свободный член для частоты процессора:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.processor_frequency_offset" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Весовой коэффициент для процессора:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.processor_weight" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Коэффициент для поколения ОЗУ:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.ram_generation_factor" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Свободный член для поколения ОЗУ:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.ram_generation_offset" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Коэффициент для частоты ОЗУ:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.ram_frequency_factor" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Коэффициент для частоты ОЗУ:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.ram_frequency_offset" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Коэффициент для объема памяти ОЗУ:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.ram_memory_size_factor" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Свободный член для объема памяти ОЗУ:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.ram_memory_size_offset" type="number"/>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label>Весовой коэффициентя для ОЗУ:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input v-model="software.ram_weight" type="number"/>
          </b-col>
        </b-row>

      </b-container>
    </b-form>

    <div slot="footer">
      <b-button variant="success" type="submit" class="mr-1" form="softwareCreateForm">
        Сохранить
      </b-button>
    </div>

  </b-card>
</template>

<script>

  import softwareApi from "api/tickets/softwareApi";

  export default {
    name: "Software",
    data() {
      return {
        software: {},
      }
    },
    created() {
      this.fetchData();
    },
    methods: {
      async fetchData() {
        if (!this.$route.params.id) return;
        this.software = await softwareApi.show(this.$route.params.id);
      },
      storeOrUpdate() {
        if (!this.$route.params.id) {
          this.store();
        } else {
          this.update();
        }
      },
      async store() {
        await softwareApi.store(this.software);
        this.alertSuccess();
        this.$router.push('/software');
      },
      async update() {
        await softwareApi.update(this.$route.params.id, this.software);
        this.alertSuccess();
      }
    }
  }
</script>

<style scoped>
  .software-card {
    width: 100%;
  }
</style>
