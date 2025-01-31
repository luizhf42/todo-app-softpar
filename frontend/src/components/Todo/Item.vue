<template>
  <li :class="todo.status">
    <div class="todo">
      <h3>
        {{ todo.title }}
      </h3>
      <ItemActions
        @toggle-details="updateShowDetails"
        :todo
        @update-todo="updateTodo"
      />
    </div>
    <transition name="details-fade">
      <div v-show="showDetails" class="details">
        <p>{{ todo.description }}</p>
        <div>Criada em {{ formatDate(todo.created_at) }}</div>
        <div v-if="todo.completed_at">
          Concluída em {{ formatDate(todo.completed_at) }}
        </div>
      </div>
    </transition>
  </li>
</template>

<script setup lang="ts">
import type { Todo } from "src/types/todo";
import { ref } from "vue";
import ItemActions from "./ItemActions.vue";

const props = defineProps<{
  todo: Todo;
}>();

const todo = ref(props.todo);

const showDetails = ref(false);

const formatDate = (date: Date) => {
  const newDate = new Intl.DateTimeFormat("pt-BR", {
    dateStyle: "short",
    timeStyle: "short",
  }).format(new Date(date));

  return newDate;
};

const updateShowDetails = (newShowDetails: boolean) => {
  showDetails.value = newShowDetails;
};

const updateTodo = (newTodo: Todo) => {
  todo.value = newTodo;
};
</script>

<style lang="css" scoped>
li {
  background: #f4f4f4;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  border: 1px solid var(--primary);
  margin-bottom: 1em;
  padding: 0.75rem 1rem;

  &.completed {
    text-decoration: line-through;
    border-color: var(--completed);

    select {
      outline-color: var(--completed);
      border-color: var(--completed);
    }
  }

  &.pending {
    border-color: var(--pending);

    select {
      outline-color: var(--pending);
      border-color: var(--pending);
    }
  }

  .todo {
    display: flex;
    justify-content: space-between;
    align-items: center;

    h3 {
      width: 100%;
      font-size: 1.3rem;
      font-weight: 500;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }

  .details {
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #ddd;
    font-size: 0.9rem;
    color: #555;

    p {
      margin: 0 0 8px;
    }
  }
}
.details-fade-enter-active,
.details-fade-leave-active {
  transition: all 0.3s ease;
}

.details-fade-enter-from,
.details-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

.details-fade-enter-to,
.details-fade-leave-from {
  opacity: 1;
  transform: translateY(0);
}

@media screen and (max-width: 500px) {
  .todo {
    flex-direction: column;
    gap: 1rem;

    h3 {
      text-align: center;
      font-size: 1.1rem;
    }
  }
}
</style>
