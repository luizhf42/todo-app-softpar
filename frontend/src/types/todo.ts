export interface Todo {
  id: number;
  title: string;
  description: string;
  created_at: Date;
  completed_at: Date | null;
  status: "pending" | "in progress" | "completed";
}
