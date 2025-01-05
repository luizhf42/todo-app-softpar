<template>
  <ul>
    <TodoItem v-for="todo in todos" :key="todo.id" :todo="todo" />
  </ul>
  <div v-if="isLoading">Carregando suas tarefas...</div>
  <div v-if="todos.length === 0 && !isLoading">Nenhuma tarefa a exibir!</div>
</template>

<script setup lang="ts">
import TodoItem from "./Item.vue";
import type { Todo } from "src/types/todo";

defineProps<{
  todos: Todo[];
  isLoading: boolean;
}>();
</script>

<style lang="css" scoped>
ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

div {
  text-align: center;
}
</style>
