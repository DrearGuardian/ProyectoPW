import { Component, OnInit } from '@angular/core';
import { UsersService } from '../../services/users.service';
import { User } from '../../models/user';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import * as Hash from 'bcryptjs';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  users: User[] = [];
  password: string = '';
  userMail: string = '';

  constructor(private userService: UsersService, private router: Router) {}

  ngOnInit(): void {
    this.userService.getUsers().subscribe((data: User[]) => {
      this.users = data;
      console.log(this.users);
    });
  }

  login() {
    const userMail = this.userMail;
    const password = this.password;

    // Verificar si las credenciales coinciden con algún usuario
    const user = this.users.find(user => user.email === userMail);

    if (user && Hash.compareSync(password, user.password)) {
      this.router.navigate(['/menu/home']);
    } else {
      alert('Usuario o contraseña incorrectos');
    }
  }
}

