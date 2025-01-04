<template>
  <form @submit="addTodo">
    <label>
      Título:
      <input v-model.trim="title" />
    </label>
    <label>
      Descrição:
      <input v-model.trim="description"
    /></label>
    <button class="primary-button" :disabled="areInputsEmpty">
      + Adicionar tarefa
    </button>
  </form>
</template>

<script setup lang="ts">
import { useTodosStore } from "src/stores/todos";
import { computed, ref } from "vue";

const title = ref("");
const description = ref("");
const areInputsEmpty = computed(
  () => title.value === "" || description.value === ""
);
const { createTodo } = useTodosStore();

const addTodo = () => {
  if (!areInputsEmpty.value) {
    createTodo(title.value, description.value);
    title.value = "";
    description.value = "";
  }
};
</script>

<style lang="css" scoped>
form {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1rem 0;
  border-bottom: 1px solid #94a3b8;
}
</style>
