<template>
  <ul>
    <TodoItem v-for="todo in todos" :key="todo.id" :todo="todo" />
  </ul>
  <div class="no-todos" v-if="todos.length === 0">Nenhuma tarefa a exibir!</div>
</template>

<script setup lang="ts">
import TodoItem from "./Item.vue";
import type { Todo } from "src/types/todo";

defineProps<{
  todos: Todo[];
}>();
</script>

<style lang="css" scoped>
ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.no-todos {
  text-align: center;
}
</style>
