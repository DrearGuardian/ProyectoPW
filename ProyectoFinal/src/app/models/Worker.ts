export class Worker {
  id: number;
  name: string;
  company: string;
  address: string;
  created_at: Date;
  updated_at: Date;

  constructor() {
    this.id = 0;
    this.name = '';
    this.company = '';
    this.address = '';
    this.created_at = new Date();
    this.updated_at = new Date();
  }
}
