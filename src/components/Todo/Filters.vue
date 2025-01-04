<template>
  <div>
    <label>Data: <input type="date" v-model="filterDate" /></label>
    <label>
      Status:
      <select v-model="filterStatus">
        <option selected value="all">Todas</option>
        <option value="pending">Pendentes</option>
        <option value="in progress">Em andamento</option>
        <option value="completed">Concluídas</option>
      </select>
    </label>
    <label>
      Ordenar por:
      <select v-model="orderBy">
        <option selected value="date">Data</option>
        <option value="title">Título</option>
      </select>
    </label>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";

const emit = defineEmits(["update-filters"]);
const filterStatus = ref<"all" | "pending" | "in progress" | "completed">(
  "all"
);
const filterDate = ref<string | null>(null);
const orderBy = ref<"date" | "title">("date");

watch([filterStatus, filterDate, orderBy], () => {
  const filters = {
    status: filterStatus.value,
    date: filterDate.value,
    orderBy: orderBy.value,
  };
  emit("update-filters", filters);
});
</script>

<style lang="css" scoped>
div {
  display: flex;
  gap: 10px;
  margin-bottom: 1rem;
}

@media screen and (max-width: 500px) {
  div {
    flex-direction: column;
  }
}
</style>
