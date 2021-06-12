import React from "react";

export class StoreAccessForDebug extends React.Component {
  constructor(props) {
    super(props);
    this.storeValue = this.getStoreContent();
    this.state = {
      store: this.getStoreContent()
    }
  }

  componentDidMount() {
    this.unsubscriber = this.props.store.subscribe(() => {this.setState({store: this.getStoreContent()})});
  }

  componentWillUnmount() {
    this.unsubscriber();
  }

  getStoreContent() {
    return JSON.stringify(this.props.store.getState(), null, 2);
  }

  render() {
    return (
      <div style={{padding: '17%'}} className="bg-primary">
        <pre className="text-light">
          { this.state.store }
        </pre>
      </div>
    );
  }
}
