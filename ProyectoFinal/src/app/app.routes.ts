import { Routes } from '@angular/router';
import { LoginComponent } from './components/login/login.component';
import { HomeComponent } from './components/home/home.component';
import { MenuComponent } from './components/menu/menu.component';
import { WorkerComponent } from './components/admin/Worker/Worker.component';
import { ProductComponent } from './components/admin/product/product.component';
import { CategoryComponent } from './components/admin/category/category.component';
import { UserComponent } from './components/admin/user/user.component';

export const routes: Routes = [
  { path: '', component: LoginComponent },
  { path: 'login', component: LoginComponent },
  {
    path: 'menu',
    component: MenuComponent,
    children: [
      { path: 'home', component: HomeComponent },
      { path: 'worker', component: WorkerComponent }, // Reemplazar con el componente correcto
      { path: 'product', component: ProductComponent }, // Reemplazar con el componente correcto
      { path: 'category', component: CategoryComponent }, // Reemplazar con el componente correcto
      { path: 'user', component: UserComponent } // Reemplazar con el componente correcto
    ],
  },
];
