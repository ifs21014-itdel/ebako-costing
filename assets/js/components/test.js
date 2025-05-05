
            if(this.new_material.allowance=="")
                this.new_material.allowance=0;
            if (this.new_material.categoryid == "6" || this.new_material.categoryid == 6) {
                var req_qty = parseFloat(this.new_material.qty) * parseFloat(this.new_material.yield);
            } else {

                if (this.new_material.yield == 0) {
                    var req_qty = ((parseFloat(this.new_material.qty)) * (1 + parseFloat(this.new_material.allowance)));
                } else {
                    var req_qty = ((parseFloat(this.new_material.qty) / parseFloat(this.new_material.yield)) * (1 + parseFloat(this.new_material.allowance)));

                }

            }
            this.req_qty = roundTo3(req_qty);
            this.new_material.req_qty = this.req_qty;
            return this.req_qty;