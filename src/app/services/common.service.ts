import { Injectable } from '@angular/core';
import { DataService } from './data.service';

@Injectable({
  providedIn: 'root'
})
export class CommonService {

  constructor(public _ds: DataService) { }

  // @param1 API end point:
  // @param2 payload to be send in API:
  // @param3 http request settings
  async commonSubscribe(endpoint: any, payload: any, httpsettings: any) {
    return new Promise((resolved, rejects) => {
      this._ds._httpRequest(endpoint, payload, httpsettings).subscribe(async (dt: any) => {
        resolved(dt = await dt);
      });
    });
  }
}
