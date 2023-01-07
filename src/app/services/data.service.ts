import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DataService {

  SharedData: any;
  public prefix: string = 'GC'; 
  public baseURL: string = 'http://localhost/deesgym/backend/';
  public nodeBaseURL: string = 'gordoncollegeccs.edu.ph:4230/nodeapi/' // NODE
  public fileUrl: string = 'https://gordoncollegeccs.edu.ph:4230/api';
  public imageURL: string = 'http://localhost/GC-LAMP-Faculty/requests/';
  // public booksURL: string = 'http://localhost/LAMP/documents/books/'
  // Staging
  // public prefix: string; 
  public booksURL: string = "https://gordoncollegeccs.edu.ph/downloads/books/"
 
  constructor(private _http: HttpClient) {
    // this.baseURL = cfg.baseURL
    // this.fileUrl = cfg.fileUrl
    // this.prefix = cfg.prefix
    // this.imageURL = cfg.imgURL
  }

  private subject = new Subject<any>();

  sendUpdate(message: string) {
    this.subject.next({ text: message });
  }

  getUpdate(): Observable<any> {
    return this.subject.asObservable();
  }
  
  _httpRequest(api: string, load: any, sw: number) {
    this.baseURL = 'http://localhost/deesgym/backend/';
    // let userDevice: string = this._user.isMobile() ? 'Web Access using Mobile phone' : 'Web Access using Desktop/Laptop';

    let result: any;
    switch (sw) {
      case 1:
        result = this._http.get(this.baseURL + api);
        break;
      case 2:
        result = this._http.post(this.baseURL + api, JSON.stringify(load));
        break;
      case 3:
        let d = {
          // param1: this._user.getUserID(),
          // param2: this._user.getToken(),
          // param3: 1,
          // param4: userDevice,
          // param5: this._user.getRole(),
          // param6: this._user.getFullname(),
          // param7: this._user.getDepartment(),
          // param8: this._user.getProgram()
        };

        load.append('auth', JSON.stringify(d));
        result = this._http.post(this.baseURL + api, load);
        console.log(result)

        break;
      case 4:
        result = this._http.post(this.baseURL + api, (JSON.stringify(load)));
        console.log(result)

        break;
      // Papalitan ni louds
      case 5:
        result = this._http.post(this.fileUrl + api, unescape(encodeURIComponent(JSON.stringify(load))));
        console.log(result)

        break;
      default: break;
    }


    return result;
  }
}
