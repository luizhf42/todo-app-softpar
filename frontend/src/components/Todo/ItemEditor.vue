<template>
  <div class="wrapper" v-show="openEditor">
    <dialog open>
      <h2>Editar Tarefa "{{ todo.title }}"</h2>
      <form>
        <label>
          Título:
          <input type="text" v-model="newTitle" ref="titleInput" />
        </label>
        <label>
          Descrição:
          <input type="text" v-model="newDescription" />
        </label>
        <div class="buttons">
          <button @click.prevent="emit('cancel')" class="cancel-button">
            Cancelar
          </button>
          <button
            @click.prevent="handleSubmit"
            class="primary-button"
            :disabled="areInputsEmpty"
          >
            Salvar
          </button>
        </div>
      </form>
    </dialog>
  </div>
</template>

<script setup lang="ts">
import { useTodosStore } from "src/stores/todos";
import type { Todo } from "src/types/todo";
import { computed, nextTick, ref, watch } from "vue";

const { todo, openEditor } = defineProps<{
  openEditor: boolean;
  todo: Todo;
}>();

const emit = defineEmits(["cancel", "submit"]);

const { updateTodo } = useTodosStore();
const newTitle = ref(todo.title);
const newDescription = ref(todo.description);
const areInputsEmpty = computed(
  () => newTitle.value === "" || newDescription.value === ""
);

const titleInput = ref<HTMLInputElement | null>(null);
watch(
  () => openEditor,
  async (isOpen) => {
    if (isOpen) {
      await nextTick();
      titleInput.value?.focus();
    }
  }
);

const handleSubmit = async () => {
  if (!areInputsEmpty.value) {
    const updatedTodo = await updateTodo(todo.id, {
      title: newTitle.value,
      description: newDescription.value,
    });
    emit("submit", updatedTodo);
  }
};
</script>

<style lang="css" scoped>
.wrapper {
  position: fixed;
  inset: 0;
  margin: auto;
  background: #042b4146;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;

  dialog {
    margin: auto;
    width: min(90%, 500px);
    padding: 1rem;
    border-radius: 0.5rem;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    h2 {
      margin-bottom: 1rem;
      font-size: 1.5rem;
      font-weight: 700;
    }

    .buttons {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 1rem;
    }

    .cancel-button {
      border: none;
      color: #b31f1f;
      text-decoration: underline;
      font-weight: 500;
      cursor: pointer;
    }
  }
}
</style>
