import { Component, OnInit } from '@angular/core';
import {
  FormGroup,
  FormBuilder,
  FormControl,
  Validators,
} from '@angular/forms';
import { DataService } from 'src/app/services/data.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-add-transaction',
  templateUrl: './add-transaction.component.html',
  styleUrls: ['./add-transaction.component.scss'],
})
export class AddTransactionComponent implements OnInit {

  members: any = [];
  form: FormGroup;
  constructor(private fb: FormBuilder, private ds: DataService) {}

  ngOnInit(): void {
    this.getMembers();
    this.form = this.fb.group({
      radio: new FormControl('', Validators.required),
    });
  }

  getMembers() {
    this.ds._httpRequest('members', null, 1).subscribe((data:any)=>{
      this.members = data.payload
    });
  }

  addTransactionAlert() {
    Swal.fire({
      title: 'All good?',
      text: 'You are about to make a new transaction, do you wish to proceed?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#004643',
      cancelButtonColor: '#e16162',
      confirmButtonText: 'Yes, complete transaction',
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Success',
          text: 'This transaction has been made.',
          icon: 'success',
          confirmButtonColor: '#004643',
        });
      }
    });
  }
}
