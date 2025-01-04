<template>
  <div class="actions">
    <select v-model="todo.status" @change="handleStatusChange">
      <option value="pending">Pendente</option>
      <option value="in progress">Em andamento</option>
      <option value="completed">Concluída</option>
    </select>
    <div class="buttons">
      <button @click="openEditor = true">
        <q-icon :name="fasPencil" size="1.25rem" class="edit" />
      </button>
      <button @click="deleteTodo(todo.id)">
        <q-icon :name="fasTrash" size="1.25rem" class="delete" />
      </button>
      <button @click="toggleDetails">
        <q-icon
          :name="showDetails ? fasChevronUp : fasChevronDown"
          size="1.25rem"
          :class="`dropdown ${todo.status}`"
        />
      </button>
    </div>
  </div>

  <Teleport to="body">
    <ItemEditor :openEditor :todo @close-dialog="() => (openEditor = false)" />
  </Teleport>
</template>

<script setup lang="ts">
import {
  fasPencil,
  fasTrash,
  fasChevronDown,
  fasChevronUp,
} from "@quasar/extras/fontawesome-v6";
import { useTodosStore } from "src/stores/todos";
import type { Todo } from "src/types/todo";
import { ref } from "vue";
import ItemEditor from "./ItemEditor.vue";

const props = defineProps<{
  todo: Todo;
}>();

const emit = defineEmits(["toggle-details"]);

const todo = ref(props.todo);
const { updateStatus, deleteTodo } = useTodosStore();
const showDetails = ref(false);
const openEditor = ref(false);

const toggleDetails = () => {
  showDetails.value = !showDetails.value;
  emit("toggle-details", showDetails.value);
};

const handleStatusChange = () => {
  todo.value = updateStatus(todo.value.id, todo.value.status);
};
</script>

<style lang="css" scoped>
.actions,
.buttons {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
  flex-shrink: 0;

  button {
    display: flex;
    align-items: center;
    padding: 0;
    border: none;
    background: transparent;

    i {
      cursor: pointer;
      filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.1));

      &.delete {
        color: #b31f1f;
      }
      &.edit {
        color: #aeae29;
      }

      &.dropdown {
        color: var(--primary);
        &.completed {
          color: #196619;
        }
        &.pending {
          color: #c1c113;
        }
      }
    }
  }
}
</style>
