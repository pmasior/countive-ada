import React from "react";
import { DataTypes } from "./Types";
import SettingsDisplay from "../components/Dashboard2/SettingsDisplay";

export const DataGetter = (dataType, WrappedComponent) => {
  return class extends React.Component {
    render() {
      return <WrappedComponent {...this.props} />;
    }

    componentDidMount() {
      if (dataType === DataTypes.CATEGORIES && WrappedComponent !== SettingsDisplay) {
        this.props.getData(DataTypes.CATEGORIES);
      }
      if (dataType === DataTypes.SUBCATEGORIES && WrappedComponent !== SettingsDisplay) {
        this.props.getData(DataTypes.ICONS);
        this.props.getData(DataTypes.SUBCATEGORIES);
      }
      if (dataType === DataTypes.TRANSACTIONS && WrappedComponent !== SettingsDisplay) {
        this.props.getData(DataTypes.TRANSACTIONS);
        this.props.getData(DataTypes.CURRENCIES);
        this.props.getData(DataTypes.METHOD_OF_PAYMENTS);
        this.props.getData(DataTypes.SETTLEMENT_ACCOUNTS);
      }
      if (WrappedComponent === SettingsDisplay) {
        // this.props.getData(DataTypes.CATEGORIES);
        this.props.getData(DataTypes.SUBCATEGORIES);
        this.props.getData(DataTypes.METHOD_OF_PAYMENTS);
        this.props.getData(DataTypes.SETTLEMENT_ACCOUNTS);
        this.props.getData(DataTypes.ICONS);

      }
    }
  }
}
