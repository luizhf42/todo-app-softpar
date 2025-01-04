export interface Todo {
  id: number;
  title: string;
  description: string;
  createdAt: Date;
  completedAt: Date | null;
  status: "pending" | "in progress" | "completed";
}
