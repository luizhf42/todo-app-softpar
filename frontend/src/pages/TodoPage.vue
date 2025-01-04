<template>
  <div>
    <TodoForm />
    <h2>Tarefas</h2>
    <TodoFilters @update-filters="updateFilters" />
    <TodoList :todos="filteredAndOrderedTodos" />
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import { useTodosStore } from "src/stores/todos";
import TodoForm from "src/components/Todo/Form.vue";
import TodoFilters from "src/components/Todo/Filters.vue";
import TodoList from "src/components/Todo/List.vue";

type FilterStatus = "all" | "pending" | "in progress" | "completed";
type OrderBy = "date" | "title";

const todoStore = useTodosStore();
const filterStatus = ref<FilterStatus>("all");
const filterDate = ref<string | null>(null);
const orderBy = ref<OrderBy>("date");

const updateFilters = (filters: {
  status: FilterStatus;
  date: string;
  orderBy: OrderBy;
}) => {
  filterStatus.value = filters.status;
  filterDate.value = filters.date;
  orderBy.value = filters.orderBy;
};

const filteredAndOrderedTodos = computed(() => {
  let todos = [...todoStore.todos];

  if (filterStatus.value !== "all") {
    todos = todos.filter((todo) => todo.status === filterStatus.value);
  }

  if (filterDate.value) {
    const selectedDate = new Date(filterDate.value).toISOString().split("T")[0];
    todos = todos.filter((todo) => {
      const createdDate = new Date(todo.createdAt).toISOString().split("T")[0];
      return createdDate === selectedDate;
    });
  }

  todos.sort((a, b) => {
    if (orderBy.value === "date") {
      return new Date(a.createdAt).getTime() - new Date(b.createdAt).getTime();
    } else if (orderBy.value === "title") {
      return a.title.localeCompare(b.title);
    }
    return 0;
  });

  return todos;
});
</script>

<style lang="css" scoped>
h2 {
  font-size: 1.5rem;
  text-align: center;
  font-weight: 700;
  padding: 1rem 0;
}
</style>
