<template>
  <header>
    <h1>Lista de Tarefas</h1>
  </header>

  <main><router-view /></main>
</template>

<script setup lang="ts"></script>

<style lang="css" scoped>
header {
  background-color: var(--primary);
  color: white;
  text-align: center;
  padding: 0.5rem;

  h1 {
    height: min-content;
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
  }
}

main {
  width: min(90%, 600px);
  margin: 0 auto;
  padding: 1rem 0;
}
</style>
