import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { MatTableDataSource, MatTableModule } from '@angular/material/table';
import { MatPaginator, MatPaginatorModule } from '@angular/material/paginator';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSort, MatSortModule } from '@angular/material/sort';
import { Worker } from '../../../models/Worker';
import { WorkersService } from '../../../services/Workers.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-Worker',
  standalone: true,
  imports: [
    MatTableModule,
    MatPaginatorModule,
    MatFormFieldModule,
    MatInputModule,
    MatSortModule,
    CommonModule,
    FormsModule,
  ],
  templateUrl: './Worker.component.html',
  styleUrl: './Worker.component.css',
})
export class WorkerComponent implements OnInit {
  Worker: Worker = new Worker();
  createOpen = false;
  editOpen = false;
  Workers: Worker[] = [];
  displayedColumns: string[] = [
    'id',
    'name',
    'company',
    'address',
    'acciones'
  ];
  dataSource = new MatTableDataSource<Worker>();

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;

  constructor(private WorkerService: WorkersService, private router: Router) {}

  ngOnInit(): void {
    this.getWorkers();
  }

  ngAfterViewInit() {
    this.dataSource.paginator = this.paginator;
    this.dataSource.sort = this.sort;
  }

  getWorkers() {
    this.WorkerService.getWorkers().subscribe({
      next: (datos: Worker[]) => {
        this.Workers = datos;
        console.log(this.Workers);
        this.dataSource.data = this.Workers;
      },
      error: (errores: any) => console.log(errores),
    });
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }

  openCreate() {
    this.createOpen = true;
  }

  openEdit(updateWorker: Worker) {
    this.editOpen = true;
    this.Worker.id = updateWorker.id;
    this.Worker.name = updateWorker.name;
    this.Worker.company = updateWorker.company;
    this.Worker.address = updateWorker.address;
    this.Worker.created_at = updateWorker.created_at;
    this.Worker.updated_at = updateWorker.updated_at;
  }

  closeModal() {
    this.createOpen = false;
    this.editOpen = false;
    this.Worker = new Worker();
  }

  createWorker() {
    // Lógica para crear un nuevo usuario
    this.WorkerService.insertWorker(this.Worker).subscribe({
      next: (result: any) => {
        console.log(result);
        Swal.fire({
          title: 'Proveedor Insertado!',
          text: 'Registro Exitoso!',
          icon: 'success',
        });
        this.closeModal(); // Cierra el modal después de crear el usuari
        this.getWorkers();
      },
      error: (errores: { toString: () => any; }) => {
        console.log(errores);
        Swal.fire({
          title: 'Proveedor No Insertado!',
          text: errores.toString(),
          icon: 'error',
        });
      },
    });
  }

  deleteWorker(id: number) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: '¡No podrás recuperar este Proveedor!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        this.WorkerService.deleteWorker(id).subscribe({
          next: (response: any) => {
            Swal.fire({
              title: '¡Eliminado!',
              text: 'El Proveedor ha sido eliminado con éxito.',
              icon: 'success',
            });
            // Opcional: Actualizar la lista de usuarios después de eliminar
            this.getWorkers();
          },
          error: (error: any) => {
            console.error(error);
            Swal.fire({
              title: 'Error',
              text: 'No se pudo eliminar al Proveedor.',
              icon: 'error',
            });
          },
        });
      }
    });
  }

  updateWorker() {
    this.WorkerService.updateWorker(this.Worker.id, this.Worker).subscribe({
      next: (response: any) => {
        Swal.fire({
          title: '¡Actualizado!',
          text: 'El Proveedor ha sido actualizado correctamente.',
          icon: 'success',
        });
        this.closeModal(); // Cierra el modal después de la actualización
        this.getWorkers(); // Actualiza la lista de usuarios si estás mostrando una tabla
      },
      error: (error: any) => {
        console.error(error);
        Swal.fire({
          title: 'Error',
          text: 'No se pudo actualizar al Proveedor.',
          icon: 'error',
        });
      },
    });
  }
}
