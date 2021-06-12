import React from "react";

export class RequestError extends React.Component {
  cancelCallback() {
    window.history.back();
  }

  goToLogin() {
    window.location.replace("/login");
  }

  stopPropagation(event) {
    event.stopPropagation();
  }

  render() {
    return (
      <>
        <div className="modal-backdrop fade show"
             onClick={this.cancelCallback}/>
        <div className="modal fade in show" id="exampleModal" tabIndex="-1"
             style={{display: 'block'}}
             role="dialog"
             aria-modal="true"
             onClick={this.cancelCallback}>
          <div className="modal-dialog"
               onClick={this.stopPropagation}>
            <div className="modal-content">
              <form>
                <div className="modal-header">
                  <h5 className="modal-title" id="exampleModalLabel">
                    {this.props.match.params.code} error occurred
                  </h5>
                  <button type="button" className="btn-close" data-bs-dismiss="modal"
                          aria-label="Close"
                          onClick={this.cancelCallback}/>
                </div>
                <div className="modal-body">
                  <div className="form-group form-floating mb-3">
                    {this.props.match.params.message}
                  </div>
                </div>
                <div className="modal-footer d-flex">
                  <span className="flex-grow-1" />
                  {this.props.match.params.code === "401" &&
                    <button type="button" className="btn btn-secondary"
                            data-bs-dismiss="modal"
                            onClick={this.goToLogin}>
                      Go to login
                    </button>
                    ||
                    <button type="button" className="btn btn-secondary"
                            onClick={this.cancelCallback}>
                      Go to dashboard
                    </button>
                  }
                </div>
              </form>
            </div>
          </div>
        </div>
      </>
    );
  }
}
