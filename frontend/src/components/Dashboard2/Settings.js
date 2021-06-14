import React from "react";
import SidebarConnector from "./SidebarConnector";
import {EditorConnector} from "./EditorConnector";
import {DataTypes} from "../../data/Types";
import Navbar from "./Navbar";
import SettingsConnector from "./SettingsConnector";
import SubcategoryEditor from "../Dashboard2/SubcategoryEditor";
import CategoryEditor from "./CategoryEditor";
import SettlementAccountEditor from "./SettlementAccountEditor";
import MethodOfPaymentEditor from "./MethodOfPaymentEditor";

const ConnectedSidebar = SidebarConnector();
const ConnectedSettings = SettingsConnector();
const ConnectedCategoryEditor = EditorConnector(DataTypes.CATEGORIES, CategoryEditor);
const ConnectedSubcategoryEditor = EditorConnector(DataTypes.SUBCATEGORIES, SubcategoryEditor);
const ConnectedSettlementAccountEditor = EditorConnector(DataTypes.SETTLEMENT_ACCOUNTS, SettlementAccountEditor);
const ConnectedMethodOfPaymentEditor = EditorConnector(DataTypes.METHOD_OF_PAYMENTS, MethodOfPaymentEditor);

export const Settings =
  (props) => {
    const modeParam = props.match.params.mode;
    const dataTypeParam = props.match.params.datatype;

    return (
      <div>
        <header className="navbar bg-light sticky-top flex-md-nowrap shadow-sm justify-content-start">
          <Navbar />
        </header>
        <div className="container-fluid">
          <div className="row">
            <nav className="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse shadow-sm
                            position-fixed top-0 mt-5 p-2 h-auto" style={{'zIndex': '100'}}
                 id="sidebarMenu">
              <div className="d-none d-md-block vh-100 float-start"/>
              <ConnectedSidebar />
            </nav>
            <main className="col-md-10 ms-md-auto d-md-flex">
              <ConnectedSettings />
            </main>
          </div>
        </div>
        {(modeParam === "create") && (dataTypeParam === "categories") &&
          <ConnectedCategoryEditor headerTitle="Add category"/>
        }
        {(modeParam === "edit") && (dataTypeParam === "categories") &&
          <ConnectedCategoryEditor headerTitle="Edit category"/>
        }
        {(modeParam === "create") && (dataTypeParam === "subcategories") &&
          <ConnectedSubcategoryEditor headerTitle="Add subcategory"/>
        }
        {(modeParam === "edit") && (dataTypeParam === "subcategories") &&
          <ConnectedSubcategoryEditor headerTitle="Edit subcategory"/>
        }
        {(modeParam === "create") && (dataTypeParam === "settlement_accounts") &&
          <ConnectedSettlementAccountEditor headerTitle="Add settlement account"/>
        }
        {(modeParam === "edit") && (dataTypeParam === "settlement_accounts") &&
          <ConnectedSettlementAccountEditor headerTitle="Edit settlement account"/>
        }
        {(modeParam === "create") && (dataTypeParam === "method_of_payments") &&
          <ConnectedMethodOfPaymentEditor headerTitle="Add method of payment"/>
        }
        {(modeParam === "edit") && (dataTypeParam === "method_of_payments") &&
          <ConnectedMethodOfPaymentEditor headerTitle="Edit method of payment"/>
        }
      </div>
    );
  }
