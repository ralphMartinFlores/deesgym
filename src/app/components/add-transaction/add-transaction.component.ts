import { DatePipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import {
  FormGroup,
  FormBuilder,
  FormControl,
  Validators,
} from '@angular/forms';
import { MatDialog } from '@angular/material/dialog';
import { Subscription } from 'rxjs';
import { DataService } from 'src/app/services/data.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-add-transaction',
  templateUrl: './add-transaction.component.html',
  styleUrls: ['./add-transaction.component.scss'],
})
export class AddTransactionComponent implements OnInit {
  filterTerm!: string;
  message: any;
  private subs: Subscription;
  memberAutoComplete = new FormControl('');

  members: any = [];
  form: FormGroup;
  constructor(
    private fb: FormBuilder,
    private ds: DataService,
    private datepipe: DatePipe,
    private dialog: MatDialog
  ) {
    this.subs = this.ds.getUpdate().subscribe((message) => {
      this.message = message;
      this.ngOnInit();
    });
  }

  ngOnInit(): void {
    this.getMembers();
    this.form = this.fb.group({
      radio: new FormControl('', Validators.required),
    });
  }

  sendMessage(): void {
    this.ds.sendUpdate('Message from Sender Component to Receiver Component!');
  }

  getMembers() {
    this.ds._httpRequest('members', null, 1).subscribe((data: any) => {
      this.members = data.payload;
      console.log(this.members);
    });
  }

  onSubmit(e: any) {
    let date = new Date();
    let type = '';
    let f = e.target.elements;
    let load = {}
    if (this.form.value.radio == 1) {
      type = 'Walk-In';
      load = {
        trans_name: f.lname.value + ', ' + f.fname.value + ' ' + f.mname.value,
        trans_type: type,
        trans_date: this.datepipe.transform(date, 'yyyy-MM-dd'),
        trans_timein: this.datepipe.transform(date, 'hh:mm a'),
      };
    } else {
      type = 'Member';
      load = {
        trans_name: f.name.value,
        trans_type: type,
        trans_date: this.datepipe.transform(date, 'yyyy-MM-dd'),
        trans_timein: this.datepipe.transform(date, 'hh:mm a'),
      };
    }

    Swal.fire({
      title: 'All good?',
      text: 'You are about to add a new transaction, do you wish to proceed?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#004643',
      cancelButtonColor: '#e16162',
      confirmButtonText: 'Yes, complete transaction.',
    }).then((result) => {
      if (result.isConfirmed) {
        this.ds
          ._httpRequest('transactions/add', load, 2)
          .subscribe((data: any) => {
            if (data.code == 200) {
              this.sendMessage();
              Swal.fire({
                title: 'Success',
                text: 'This transaction has been made.',
                icon: 'success',
                confirmButtonColor: '#004643',
              });
              this.dialog.closeAll();
            }
          });
      }
    });
  }
}
