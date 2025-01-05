import { ref } from "vue";
import { defineStore } from "pinia";
import axios from "axios";
import type { AxiosError } from "axios";
import type { Todo } from "src/types/todo";

export const useTodosStore = defineStore("todos", () => {
  const API_BASE_URL = "http://localhost:8000/api/todos";
  const isLoading = ref(false);
  const error = ref<string | null>(null);

  const fetchTodos = async () => {
    isLoading.value = true;
    error.value = null;
    try {
      const response = await axios.get<Todo[]>(API_BASE_URL);
      todos.value = response.data;
    } catch (err) {
      const axiosError = err as AxiosError;
      error.value = axiosError.message || "Failed to fetch todos.";
    } finally {
      isLoading.value = false;
    }
  };

  const todos = ref<Todo[]>([]);

  const createTodo = async (title: string, description: string) => {
    const newTodo: Partial<Todo> = {
      title,
      description,
      created_at: new Date(),
      completed_at: null,
      status: "pending",
    };

    try {
      const response = await axios.post<Todo>(API_BASE_URL, newTodo);
      todos.value.push(response.data);
    } catch (err) {
      const axiosError = err as AxiosError;
      error.value = axiosError.message || "Failed to create todo.";
    }
  };

  const updateTodo = async (id: number, updates: Partial<Todo>) => {
    const updatedTodo = ref<Todo>();
    try {
      const response = await axios.put<Todo>(`${API_BASE_URL}/${id}`, updates);
      updatedTodo.value = response.data;
      const todoIndex = todos.value.indexOf(updatedTodo.value);
      todos.value[todoIndex] = updatedTodo.value!;
    } catch (err) {
      const axiosError = err as AxiosError;
      error.value = axiosError.message || "Failed to update status.";
    }

    return updatedTodo.value!;
  };

  const deleteTodo = async (id: number) => {
    try {
      await axios.delete(`${API_BASE_URL}/${id}`);
      todos.value = todos.value.filter((todo) => todo.id !== id);
    } catch (err) {
      const axiosError = err as AxiosError;
      error.value = axiosError.message || "Failed to delete todo.";
    }
  };

  return {
    todos,
    isLoading,
    error,
    fetchTodos,
    createTodo,
    updateTodo,
    deleteTodo,
  };
});
