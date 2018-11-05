<template>
  <div class="inputSearch">

    <b-form-input
        @input.native="input"
        :id="id"
        type="text"
        v-model.trim="value"
        :placeholder="placeholder"
        @blur.native="onBlur"
        @focus.native="onFocus"
        list="resultList"
        @keydown.down.native="onArrowDown"
        @keydown.up.native="onArrowUp"
        @keydown.enter.native.prevent="onEnter"
        @keydown.esc.native="onEsc"
        :required="required"
        autocomplete="off"
    />

    <div class="searchResult" v-if="showSearch">
      <div class="searchResultItem pointer"
           v-for="item,i in searchItems"
           :class="{ 'active': i === arrowCounter }"
           :key="i"
           @click="selectItem(item)"
           @mouseover="onMouseover(i)">
        {{item.name}}
      </div>
    </div>

  </div>
</template>

<script>
  export default {
    name: "InputSearch",
    props: {
      placeholder: {
        type: String,
        default: '',
      },
      id: {
        type: String,
        default: '',
      },
      searchTable: {
        type: String,
        default: '',
        required: true,
      },
      searchField: {
        type: String,
        default: '',
        required: true,
      },
      additionalSearchConditionals: {
        type: Array,
        default: () => [],
      },
      required: {
        type: Boolean,
        default: false,
      }
    },
    data() {
      return {
        value: null,
        showSearch: false,
        selectedItem: {},
        searchItems: [],
        arrowCounter: -1,
      }
    },
    methods: {
      input() {
        this.search();
        this.$emit('input', this.value);
        this.$emit('selectItem', null);
      },
      search() {
        if (!this.value) {
          this.searchItems = [];
          return;
        }
        if (this.value.length < 3) return;
        axios.post('search', {
          table_name: this.searchTable,
          field_name: this.searchField,
          search_string: this.value,
          search_conditionals: this.additionalSearchConditionals,
        })
          .then(response => {
            this.searchItems = response.data;
            this.showSearch = this.value !== this.selectedItem.name;
          });
      },
      selectItem(item) {
        this.value = item.name;
        this.selectedItem = item;
        this.searchItems = [];
        this.showSearch = false;
        this.$emit('selectItem', item.id);
      },
      onBlur() {
        setTimeout(() => this.showSearch = false, 300);
      },
      onFocus() {
        this.showSearch = true;
      },
      onArrowDown() {
        if (this.arrowCounter < this.searchItems.length) {
          this.arrowCounter = this.arrowCounter + 1;
        }
      },
      onArrowUp() {
        if (this.arrowCounter > 0) {
          this.arrowCounter = this.arrowCounter - 1;
        }
      },
      onEnter() {
        this.selectItem(this.searchItems[this.arrowCounter]);
        this.showSearch = false;
        this.arrowCounter = -1;
      },
      onEsc() {
        this.showSearch = false;
      },
      onMouseover(i) {
        this.arrowCounter = i;
      }
    }
  }
</script>

<style lang="scss">
  .inputSearch {
    position: relative;
  }

  .searchResult {
    display: block;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    z-index: 500;
    position: absolute;
    width: 100%;
  }

  .searchResultItem {
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    &.active {
      background: #3b95e8;
    }
  }
</style>

