import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';
import { DataService } from 'src/app/services/data.service';
import { MatDialog } from '@angular/material/dialog';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-edit-member',
  templateUrl: './edit-member.component.html',
  styleUrls: ['./edit-member.component.scss'],
})
export class EditMemberComponent implements OnInit {
  member: any;
  editMemberForm!: FormGroup;
  submitted = false;

  constructor(
    private ds: DataService,
    private dialog: MatDialog,
    private formBuilder: FormBuilder
  ) {}

  ngOnInit(): void {
    this.member = this.ds.SharedData;
    this.editMemberForm = this.formBuilder.group({
      firstName: [
        this.member.member_fname,
        [Validators.required, Validators.minLength(2)],
      ],
      middleName: [this.member.member_mname],
      lastName: [
        this.member.member_lname,
        [Validators.required, Validators.minLength(2)],
      ],
      contactNumber: [
        this.member.member_mobilenum,
        [
          Validators.required,
          Validators.pattern('^[0-9]+$'),
          Validators.maxLength(11),
          Validators.minLength(11),
        ],
      ],
      email: [
        this.member.member_email,
        [
          Validators.required,
          Validators.pattern('^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$'),
        ],
      ],
      houseNumber: [this.member.member_houseno, Validators.required],
      streetName: [this.member.member_street, Validators.required],
      barangay: [this.member.member_barangay, Validators.required],
      city: [this.member.member_city, Validators.required],
    });
  }

  get f() {
    return this.editMemberForm.controls;
  }

  updateMemberAlert() {}

  sendMessage(): void {
    this.ds.sendUpdate('Message from Sender Component to Receiver Component!');
  }

  onSubmit(e: any) {
    this.submitted = true;
    if (this.editMemberForm.invalid) {
      console.log('Add Member Form Message: Form is invalid.');
    } else {
      let f = e.target.elements;
      let load = {
        member_fname: f.fname.value,
        member_mname: f.mname.value,
        member_lname: f.lname.value,
        member_mobilenum: f.mobile.value,
        member_email: f.email.value,
        member_houseno: f.houseno.value,
        member_street: f.street.value,
        member_barangay: f.barangay.value,
        member_city: f.city.value,
      };

      Swal.fire({
        title: 'All good?',
        text: 'Please make sure that all changes are final.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#004643',
        cancelButtonColor: '#e16162',
        confirmButtonText: 'Yes, save my changes.',
      }).then((result) => {
        if (result.isConfirmed) {
          this.ds
            ._httpRequest('members/update/' + f.id.value, load, 2)
            .subscribe((data: any) => {
              if (data.code == 200) {
                this.sendMessage();
                Swal.fire({
                  title: 'Success',
                  text: 'Changes have been saved.',
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
}
