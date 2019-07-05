<template>
  <div>
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
            <b-col sm="8">
              <b-form-input v-model="software.processor_number_factor" type="number" step="any"/>
            </b-col>
            <b-col sm="1">
              <b-button
                  @click="openCalculateFactorModal('processor_number_factor', 'Коэффициент для количества процессоров:')">
                <v-icon name="calculator"></v-icon>
              </b-button>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Константа для количества процессоров:</label>
            </b-col>
            <b-col sm="9">
              <b-form-input v-model="software.processor_number_offset" type="number" step="any"/>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Коэффициент для частоты процессора:</label>
            </b-col>
            <b-col sm="8">
              <b-form-input v-model="software.processor_frequency_factor" type="number" step="any"/>
            </b-col>
            <b-col sm="1">
              <b-button
                  @click="openCalculateFactorModal('processor_frequency_factor', 'Коэффициент для частоты процессора:')">
                <v-icon name="calculator"></v-icon>
              </b-button>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Константа для частоты процессора:</label>
            </b-col>
            <b-col sm="9">
              <b-form-input v-model="software.processor_frequency_offset" type="number" step="any"/>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Весовой коэффициент для процессора:</label>
            </b-col>
            <b-col sm="9">
              <b-form-input v-model="software.processor_weight" type="number" step="any"/>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Коэффициент для поколения ОЗУ:</label>
            </b-col>
            <b-col sm="8">
              <b-form-input v-model="software.ram_generation_factor" type="number" step="any"/>
            </b-col>
            <b-col sm="1">
              <b-button
                  @click="openCalculateFactorModal('ram_generation_factor', 'Коэффициент для поколения ОЗУ:')">
                <v-icon name="calculator"></v-icon>
              </b-button>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Константа для поколения ОЗУ:</label>
            </b-col>
            <b-col sm="9">
              <b-form-input v-model="software.ram_generation_offset" type="number" step="any"/>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Коэффициент для частоты ОЗУ:</label>
            </b-col>
            <b-col sm="8">
              <b-form-input v-model="software.ram_frequency_factor" type="number" step="any"/>
            </b-col>
            <b-col sm="1">
              <b-button
                  @click="openCalculateFactorModal('ram_frequency_factor', 'Коэффициент для частоты ОЗУ:')">
                <v-icon name="calculator"></v-icon>
              </b-button>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Константа для частоты ОЗУ:</label>
            </b-col>
            <b-col sm="9">
              <b-form-input v-model="software.ram_frequency_offset" type="number" step="any"/>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Коэффициент для объема памяти ОЗУ:</label>
            </b-col>
            <b-col sm="8">
              <b-form-input v-model="software.ram_memory_size_factor" type="number" step="any"/>
            </b-col>
            <b-col sm="1">
              <b-button
                  @click="openCalculateFactorModal('ram_memory_size_factor', 'Коэффициент для объема памяти ОЗУ:')">
                <v-icon name="calculator"></v-icon>
              </b-button>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Константа для объема памяти ОЗУ:</label>
            </b-col>
            <b-col sm="9">
              <b-form-input v-model="software.ram_memory_size_offset" type="number" step="any"/>
            </b-col>
          </b-row>

          <b-row class="mt-4">
            <b-col sm="3">
              <label>Весовой коэффициент для ОЗУ:</label>
            </b-col>
            <b-col sm="9">
              <b-form-input v-model="software.ram_weight" type="number" step="any"/>
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

    <b-modal id="calculateFactorModal"
             ref="calculateFactorModal"
             :title="modalTitle"
             body-class="pt-0"
             hide-footer
             class="calculateFactorModal">

      <div slot="modal-header-close">
        <img class="icon" src="/icons/close.svg" alt="Close">
      </div>

      <table class="table">
        <thead>
        <tr>
          <th scope="col"></th>
          <th v-for="i in modalColumns">{{i}}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th scope="row">x</th>
          <td v-for="column in modalMatrix">
            <b-form-input v-model="column[0]" type="number" step="any"></b-form-input>
          </td>
        </tr>
        <tr>
          <th scope="row">y</th>
          <td v-for="column in modalMatrix">
            <b-form-input v-model="column[1]" type="number" step="any"></b-form-input>
          </td>
        </tr>
        </tbody>
      </table>


      <b-button variant="success" @click="modalColumns++">Добавить столбец</b-button>
      <b-button variant="danger" @click="modalColumns--">Удалить столбец</b-button>
      <br>
      <b-button class="mt-4" variant="success" @click="calculateFactor(modalCurrentFieldName)">
        Подсчет коэффициента
      </b-button>

    </b-modal>
  </div>
</template>

<script>

  import softwareApi from "api/tickets/softwareApi";

  export default {
    name: "Software",
    data() {
      return {
        software: {},

        modalTitle: '',
        modalColumns: 3,
        modalCurrentFieldName: '',
        modalMatrix: [],
      }
    },
    created() {
      this.fetchData();
    },
    watch: {
      modalColumns: {
        immediate: true,
        handler(newValue, oldValue) {
          if (!oldValue) {
            for (let i = 0; i < newValue; i++) {
              this.modalMatrix.push([]);
            }
            return;
          }

          if (newValue > oldValue) {
            this.modalMatrix.push([]);
          } else if (newValue < oldValue) {
            this.modalMatrix.pop();
          }
        }
      }
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
      },
      openCalculateFactorModal(fieldName, modalTitle) {
        this.modalTitle = modalTitle;
        this.modalCurrentFieldName = fieldName;
        this.$refs.calculateFactorModal.show();
      },
      calculateFactor() {
        let factorValues = [];
        for (let i = 0; i < this.modalMatrix.length; i++) {
          factorValues[i] = this.modalMatrix[i][0] * this.modalMatrix[i][1];
        }
        this.software[this.modalCurrentFieldName] = factorValues.reduce((a, b) => a + b, 0) / this.modalMatrix.length;
        this.software[this.modalCurrentFieldName] = Math.round(this.software[this.modalCurrentFieldName] * 100) / 100;
        this.$refs.calculateFactorModal.hide();

        for (let i = 0; i < this.modalColumns; i++) {
          this.modalMatrix.pop();
        }
        for (let i = 0; i < this.modalColumns; i++) {
          this.modalMatrix.push([null, null]);
        }
      }
    }
  }
</script>

<style lang="scss">
  .software-card {
    width: 100%;
  }

  .calculateFactorModal {
    .modal-dialog {
      max-width: 1050px;
    }

    .input-group {
      width: 350px;
    }

    label {
      font-weight: bold;
    }
  }
</style>
