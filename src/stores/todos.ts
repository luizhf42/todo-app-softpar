import { ref } from "vue";
import { defineStore } from "pinia";
import type { Todo } from "src/types/todo";

export const useTodosStore = defineStore("todos", () => {
  const todos = ref<Todo[]>([]);
  const nextId = ref(1);

  const createTodo = (title: string, description: string) => {
    const newTodo: Todo = {
      id: nextId.value++,
      title,
      description,
      createdAt: new Date(),
      completedAt: null,
      status: "pending",
    };
    todos.value.push(newTodo);
  };

  const updateTodo = (id: number, updates: Partial<Todo>) => {
    const todo = todos.value.find((todo) => todo.id === id);
    if (todo) {
      Object.assign(todo, updates);
    }
    console.log(todo, updates);
  };

  const deleteTodo = (id: number) => {
    todos.value = todos.value.filter((todo) => todo.id !== id);
  };

  const updateStatus = (
    id: number,
    status: "pending" | "in progress" | "completed"
  ) => {
    const todo = todos.value.find((todo) => todo.id === id);
    if (todo) {
      todo.status = status;
      todo.completedAt = status === "completed" ? new Date() : null;
    }

    return todo!;
  };

  return {
    todos,
    createTodo,
    updateTodo,
    deleteTodo,
    updateStatus,
  };
});
